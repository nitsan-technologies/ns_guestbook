<?php

namespace Nitsan\NsGuestbook\Controller;

use TYPO3\CMS\Core\Mail\MailMessage;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Nitsan\NsGuestbook\Domain\Model\Nsguestbook;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use Nitsan\NsGuestbook\Domain\Repository\NsguestbookRepository;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2023
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * NsguestbookController
 */
class NsguestbookController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * nsguestbookRepository
     *
     * @var NsguestbookRepository
     */
    protected NsguestbookRepository $nsguestbookRepository;

    public $pid = 0;

    public function __construct(NsguestbookRepository $nsguestbookRepository)
    {
        $this->nsguestbookRepository = $nsguestbookRepository;
    }

    /**
     * action list
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $configuration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $this->pid = (int) $configuration['persistence']['storagePid'];
        $nsguestbooks = $this->nsguestbookRepository->findSorted($this->settings, $this->pid);
        $this->view->assign('nsguestbooks', $nsguestbooks);
        $this->view->assign('settings', $this->settings);
        return $this->htmlResponse();
    }

    /**
     * action new
     *
     * @return ResponseInterface
     */
    public function newAction(): ResponseInterface
    {
        $request = $this->request->getQueryParams()['tx_nsguestbook_form'] ?? null;
        if($this->settings['captcha'] == '0') {
            $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] =$GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] ?? '';
            $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] .= "
            <script src='https://www.google.com/recaptcha/api.js' type='text/javascript'></script>";
        }
        $request['newNsguestbook'] = $request['newNsguestbook'] ?? '';
        $this->view->assign('nsguestbookdata', $request['newNsguestbook']);
        return $this->htmlResponse();
    }

    /**
     * action create
     *
     * @param Nsguestbook $newNsguestbook
     * @return ResponseInterface
     *
     * @throws IllegalObjectTypeException
     */
    public function createAction(Nsguestbook $newNsguestbook): ResponseInterface
    {

        $settings = $this->settings;
        $error = 0;
        $mailerror = 0;
        if($this->settings['termsRequired'] == '1' && !$newNsguestbook->getTerms()) {
            $error = 1;
        }
        if ($newNsguestbook->getName() == '' || $newNsguestbook->getEmail() == '') {
            $error = 1;
        }
        if ($newNsguestbook->getEmail() != '') {
            if (filter_var($newNsguestbook->getEmail(), FILTER_VALIDATE_EMAIL)) {
            } else {
                $mailerror = 1;
            }
        }

        if (isset($_POST['g-recaptcha-response'])) {
            $captcha = $_POST['g-recaptcha-response'];
        }
        $captcha = $captcha ?? '';
        if (!$captcha && $settings['captcha'] == 0) {
            $checkcaptchamsg = LocalizationUtility::translate(
                'controller.checkcaptcha.msg',
                'ns_guestbook'
            );
            $this->addFlashMessage($checkcaptchamsg, '', ContextualFeedbackSeverity::ERROR);
            return $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
        } else {
            $secretkey = $settings['secretkey'];
            $response = json_decode(
                file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkey . '&response=' . $captcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']),
                true
            );
            if (!$response['success'] && $settings['captcha'] == 0) {
                $wrongcaptcha = LocalizationUtility::translate(
                    'controller.wrongcaptcha.msg',
                    'ns_guestbook'
                );
                $this->addFlashMessage($wrongcaptcha, '', ContextualFeedbackSeverity::ERROR);
            } else {
                if ($error == 1) {
                    $requireFields = LocalizationUtility::translate(
                        'controller.requireFields',
                        'ns_guestbook'
                    );

                    $mailfrmt = LocalizationUtility::translate(
                        'controller.mailfrmt',
                        'ns_guestbook'
                    );

                    $this->addFlashMessage($requireFields, '', ContextualFeedbackSeverity::ERROR);

                    if ($mailerror == 1) {
                        $this->addFlashMessage($mailfrmt, '', ContextualFeedbackSeverity::ERROR);
                    }

                    return $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
                }

                if ($mailerror == 1) {
                    $mailfrmt = LocalizationUtility::translate(
                        'controller.mailfrmt',
                        'ns_guestbook'
                    );
                    $this->addFlashMessage($mailfrmt, '', ContextualFeedbackSeverity::ERROR);
                    return $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
                }

                $thanksmsg = LocalizationUtility::translate(
                    'controller.thanks.msg',
                    'ns_guestbook'
                );

                $this->addFlashMessage($thanksmsg, '', ContextualFeedbackSeverity::OK);
                if ($this->settings['autoaprrove']) {
                } else {
                    $newNsguestbook->setHidden('1');
                }
                $this->nsguestbookRepository->add($newNsguestbook);

                // Username and mail
                if (!empty($this->settings['adminEmail'])) {
                    $adminName = $this->settings['adminName'];
                    $adminEmail = $this->settings['adminEmail'];

                    $confirmationContent = [
                        'adminName' => $adminName,
                        'name' => $newNsguestbook->getName(),
                        'city' => $newNsguestbook->getCity(),
                        'email' => $newNsguestbook->getEmail(),
                        'website' => $newNsguestbook->getWebsite(),
                        'message' => $newNsguestbook->getMessage(),
                    ];
                    $emailSubject = $this->settings['emailSubject'];

                    $confirmationVariables = ['guest' => $confirmationContent];

                    if(filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                        $sendSenderMail = $this->sendTemplateEmail(
                            [$adminEmail => $adminName],
                            [$adminEmail => $adminName],
                            $emailSubject,
                            'MailTemplate',
                            $confirmationVariables
                        );
                    }
                }
            }
        }
        return $this->redirect('new');
    }

    /**
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     */
    protected function sendTemplateEmail(
        array  $recipient,
        array  $sender,
        string $subject,
        string $templateName,
        array  $variables = []
    ): bool {

        /** @var StandaloneView $emailView */
        $emailView = GeneralUtility::makeInstance(StandaloneView::class);

        /*For use of Localize value */
        $extensionName = $this->request->getControllerExtensionName();
        $emailView->setRequest($this->request);

        /*For use of Localize value */
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);

        $templateRootPath = GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths']['0']);

        $templatePathAndFilename = $templateRootPath . 'Email/' . $templateName . '.html';

        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($variables);

        $emailBody = $emailView->render();
        /**@var $message MailMessage */
        $message = GeneralUtility::makeInstance(MailMessage::class);

        $message->setTo($recipient)->setFrom($sender)->setSubject($subject);
        // HTML Email
        $message->html($emailBody);

        $status = 0;
        $message->send();
        return $message->isSent();
    }

    /**
     * A template method for displaying custom error flash messages, or to
     * display no flash message at all on errors. Override this to customize
     * the flash message in your action controller.
     *
     * @return string The flash message or FALSE if no flash message should be set
     * @api
     */
    protected function getErrorFlashMessage(): string
    {
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
            'controller.insertError.msg',
            'ns_guestbook'
        );
    }
}

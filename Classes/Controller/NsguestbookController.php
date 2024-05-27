<?php

namespace Nitsan\NsGuestbook\Controller;

use TYPO3\CMS\Extbase\Annotation\Inject as inject;


/**
 * NsguestbookController
 */
class NsguestbookController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * nsguestbookRepository
     *
     * @var \Nitsan\NsGuestbook\Domain\Repository\NsguestbookRepository
     * @inject
     */
    protected $nsguestbookRepository = null;

    /*
     * Inject a NsGuestbook Repository
     *
     * @param \Nitsan\NsGuestbook\Domain\Repository\NsguestbookRepository $nsguestbookRepository
     * @return void
     */
    public function injectNsGuestbookRepository(\Nitsan\NsGuestbook\Domain\Repository\NsguestbookRepository $nsguestbookRepository)
    {
        $this->nsguestbookRepository = $nsguestbookRepository;
    }
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $currentPage = $this->request->hasArgument('currentPage')
            ? (int)$this->request->getArgument('currentPage')
            : 1;

        $itemsPerPage = (int)$this->settings['totalnumber'];
        $itemsPerPage = ($itemsPerPage < 1) ? 5 : $itemsPerPage;

        $offset = ($currentPage - 1) * $itemsPerPage;

        // Fetch the total number of items
        $totalItems = $this->nsguestbookRepository->countAll();

        // Fetch the items for the current page
        $nsguestbooks = $this->nsguestbookRepository->findByPage($offset, $itemsPerPage);

        // Calculate total pages
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Build pagination data
        $pagination = [
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'prevPage' => $currentPage > 1 ? $currentPage - 1 : null,
            'nextPage' => $currentPage < $totalPages ? $currentPage + 1 : null,
            'pages' => range(1, $totalPages),
        ];

        $this->view->assignMultiple([
            'pagination' => $pagination,
            'nsguestbooks' => $nsguestbooks,
            'settings' => $this->settings,
        ]);
    }


    /**
    * action new
    *
    * @return void
    */
    public function newAction()
    {
        $request = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_ns_guestbook_form');
        if ($this->settings['captcha'] == '0') {
            $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] = $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] ?? '';
            $GLOBALS['TSFE']->additionalFooterData[$this->request->getControllerExtensionKey()] .= "
            <script src='https://www.google.com/recaptcha/api.js' type='text/javascript'></script>";
        }
        $request['tx_nsguestbook_form']['newNsguestbook'] = isset($request['tx_nsguestbook_form']['newNsguestbook']) ? $request['tx_nsguestbook_form']['newNsguestbook'] : '';
        $this->view->assign('nsguestbookdata', $request['tx_nsguestbook_form']['newNsguestbook']);
    }

    /**
     * action create
     *
     * @param \Nitsan\NsGuestbook\Domain\Model\Nsguestbook $newNsguestbook
     * @return void
     */
    public function createAction(\Nitsan\NsGuestbook\Domain\Model\Nsguestbook $newNsguestbook)
    {
        $settings = $this->settings;
        $error = 0;
        $mailerror = 0;
        if ($this->settings['termsRequired'] == '1' && $newNsguestbook->getTerms() == false) {
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
        $captcha = isset($captcha) ? $captcha : '';
        if (!$captcha && $settings['captcha'] == 0) {
            $checkcaptchamsg = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'controller.checkcaptcha.msg',
                'ns_guestbook'
            );
            $this->addFlashMessage($checkcaptchamsg, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
        } else {
            $secretkey = $settings['secretkey'];
            $response = json_decode(
                file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkey . '&response=' . $captcha . '&remoteip=' . $_SERVER['REMOTE_ADDR']),
                true
            );
            if ($response['success'] == false && $settings['captcha'] == 0) {
                $wrongcaptcha = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'controller.wrongcaptcha.msg',
                    'ns_guestbook'
                );
                $this->addFlashMessage($wrongcaptcha, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            } else {
                if ($error == 1) {
                    $requireFields = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'controller.requireFields',
                        'ns_guestbook'
                    );

                    $mailfrmt = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'controller.mailfrmt',
                        'ns_guestbook'
                    );

                    $this->addFlashMessage($requireFields, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);

                    if ($mailerror == 1) {
                        $this->addFlashMessage($mailfrmt, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    }

                    $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
                }

                if ($mailerror == 1) {
                    $mailfrmt = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                        'controller.mailfrmt',
                        'ns_guestbook'
                    );
                    $this->addFlashMessage($mailfrmt, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                    $this->redirect('new', 'Nsguestbook', 'ns_guestbook', $_REQUEST);
                }

                $thanksmsg = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                    'controller.thanks.msg',
                    'ns_guestbook'
                );

                $this->addFlashMessage($thanksmsg, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
                if ($this->settings['autoaprrove']) {
                } else {
                    $newNsguestbook->setHidden('1');
                }
                $this->nsguestbookRepository->add($newNsguestbook);

                // User name and mail
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

                    if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL) == true) {
                        $this->sendTemplateEmail(
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
        $this->redirect('new');
    }

    /**
     * @param array $recipient recipient of the email in the format array('recipient@domain.tld' => 'Recipient Name')
     * @param array $sender sender of the email in the format array('sender@domain.tld' => 'Sender Name')
     * @param string $subject subject of the email
     * @param string $templateName template name (UpperCamelCase)
     * @param array $variables variables to be passed to the Fluid view
     */
    protected function sendTemplateEmail(
        array $recipient,
        array $sender,
        $subject,
        $templateName,
        array $variables = []
    ) {

        /** @var \TYPO3\CMS\Fluid\View\StandaloneView $emailView */
        $emailView = $this->objectManager->get('TYPO3\\CMS\\Fluid\\View\\StandaloneView');

        /*For use of Localize value */
        $extensionName = $this->request->getControllerExtensionName();
        $emailView->getRequest()->setControllerExtensionName($extensionName);

        /*For use of Localize value */
        $extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
        $templateRootPath = \TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPaths']['0']);
        $templatePathAndFilename = $templateRootPath . 'Email/' . $templateName . '.html';
        $emailView->setTemplatePathAndFilename($templatePathAndFilename);
        $emailView->assignMultiple($variables);
        $emailBody = $emailView->render();
        /** @var $message \TYPO3\CMS\Core\Mail\MailMessage */
        $message = $this->objectManager->get('TYPO3\\CMS\\Core\\Mail\\MailMessage');
        $message->setTo($recipient)
            ->setFrom($sender)
            ->setSubject($subject);
        // HTML Email
        if (version_compare(TYPO3_branch, '10.0', '>')) {
            $message->html($emailBody);
        } else {
            $message->setBody($emailBody, 'text/html');
        }

        $status = 0;
        $message->send();
        $status = $message->isSent();

        return $status;
    }

    /**
     * A template method for displaying custom error flash messages, or to
     * display no flash message at all on errors. Override this to customize
     * the flash message in your action controller.
     *
     * @return string|bool The flash message or FALSE if no flash message should be set
     * @api
     */
    protected function getErrorFlashMessage()
    {
        $errormsg = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
            'controller.insertError.msg',
            'ns_guestbook'
        );
        return $errormsg;
    }
}

<?php

namespace Dduers\T3GamingRecords\Controller;

use Exception;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RecordPictureController extends BaseController
{
    public function __construct() {}

    /**
     * LIST ACTION
     */
    public function showAction(): ResponseInterface
    {
        $recordId = $this->request->getQueryParams()['tx_t3gamingrecords_record']['recordId'] ?? 0;

        try {
            $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
            $fileReferences = $fileRepository->findByRelation('tx_t3gamingrecords_domain_model_record', 'fal_media', $recordId);
        } catch (Exception $e) {
            $fileReferences = [];
        }
        
        $this->view->assign('data', [
            'recordpicture' => $fileReferences,
        ]);

        return $this->htmlResponse();
    }
}

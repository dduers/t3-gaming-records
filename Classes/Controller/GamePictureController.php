<?php

namespace Dduers\T3GamingRecords\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class GamePictureController extends BaseController
{
    public function __construct() {}

    /**
     * LIST ACTION
     */
    public function showAction(): ResponseInterface
    {
        $gameId = $this->request->getQueryParams()['tx_t3gamingrecords_game']['gameId'] ?? 0;

        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $fileReferences = $fileRepository->findByRelation('tx_t3gamingrecords_domain_model_game', 'fal_media', $gameId);

        $this->view->assign('data', [
            'gamepicture' => $fileReferences,
        ]);

        return $this->htmlResponse();
    }
}

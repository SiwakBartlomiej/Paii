<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Model\Data;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function __construct(public Data $data)
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function dataAction()
    {
        return [
            'dzisiaj' => $this->data->dzisiaj(),
            'dni_tygodnia' => $this->data->dniTygodnia(),
        ];
    }
}

<?php declare(strict_types=1);


namespace App\Controller;


use App\Starling;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OverviewController extends Controller
{
    /** @var Starling */
    private $starling;

    public function __construct(Starling $starling)
    {
        $this->starling = $starling;
    }

    public function __invoke()
    {
        //$savingsUUID = '????????halp';
        //$monthlyContribution = $this->starling->getSavingsGoal($savingsUUID);

        return $this->render('overview.html.twig',[
            'monthlyContribution' => '██████',
            'chosenCharity' => '██████',
        ]);
    }
}
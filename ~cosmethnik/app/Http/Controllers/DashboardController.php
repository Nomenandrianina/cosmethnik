<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\DashboardRepository;
use App\Repositories\SitesRepository;
use App\Models\Sites;

class DashboardController extends Controller
{
    /** @var  DashboardRepository */
    private $dashboardRepository;
    private $sitesRepository;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DashboardRepository $dashboardRepo,SitesRepository $sitesRepo)
    {
        $this->dashboardRepository = $dashboardRepo;
        $this->sitesRepository = $sitesRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->dashboardRepository->GetData();
        return view('dashboard.index', $data);

    }

    public function catalogue(Request $request){
            $result = '';
            $ul = "<ul class='list-group list-group-flush' id='data-ul'>";
            $li = '';
            //Déterminer le Model du dossier
            $model = DeterminateObject($request->get('model'))::paginate(2);
            //Si le Model est vide
            if($model->isEmpty() == true){
                $result = "<p style='text-align:center;margin: revert;'>Aucun élément trouvé</p>";
            //Si le model n'est pas vide alors il renvoye les listes du model en HTML
            }else{
                foreach($model as $item){
                    $li .='<li class="list-group-item">
                    <a style="cursor:pointer">
                    <span class="one-span">
                            <span class="two-span">'.$item->icon().'</span>
                            <span class="three-span">'.$item->nom.'
                                 <br>';
                                if ($item->description){
                                    $li = $li.'<small>'.$item->description.'</small></span>
                                    </span>
                                    </a>
                                    </li>';
                                }
                                else{
                                    $li = $li.'<small>Aucune description</small></span>
                                            </span>
                                            </a>
                                            </li>';
                                }
                }
                $endul = "</ul> <div class='d-flex justify-content-center'>".
                $model->links() ."</div>";
                $result = $ul.$li.$endul;
            }
            return response()->json(['success'=> 200,'results' => $result]);
    }
}

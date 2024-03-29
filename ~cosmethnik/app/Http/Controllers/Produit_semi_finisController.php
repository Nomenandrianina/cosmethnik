<?php

namespace App\Http\Controllers;

use App\DataTables\Produit_semi_finisDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateProduit_semi_finisRequest;
use App\Http\Requests\UpdateProduit_semi_finisRequest;
use App\Repositories\Produit_semi_finisRepository;
use Flash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Dossiers;
use App\Models\Produit_semi_finis;

class Produit_semi_finisController extends AppBaseController
{
    /** @var  Produit_semi_finisRepository */
    private $produitSemiFinisRepository;

    public function __construct(Produit_semi_finisRepository $produitSemiFinisRepo)
    {
        $this->produitSemiFinisRepository = $produitSemiFinisRepo;
    }

    /**
     * Display a listing of the Produit_semi_finis.
     *
     * @param Produit_semi_finisDataTable $produitSemiFinisDataTable
     * @return Response
     */
    public function index(Produit_semi_finisDataTable $produitSemiFinisDataTable)
    {
        return $produitSemiFinisDataTable->render('produit_semi_finis.index');
    }

    /**
     * Show the form for creating a new Produit_semi_finis.
     *
     * @return Response
     */
    public function create()
    {
        return view('produit_semi_finis.create');
    }

    /**
     * Store a newly created Produit_semi_finis in storage.
     *
     * @param CreateProduit_semi_finisRequest $request
     *
     * @return Response
     */
    public function store(CreateProduit_semi_finisRequest $request)
    {
        $input = $request->all();

        $dossier = Dossiers::where('sites_id','=',$input['sites_id'])
            ->where('name','LIKE','%'.'produits semi-fini'.'%')
            ->orWhere('name', 'LIKE', '%'.'produit semi-finis'.'%')
            ->orWhere('name', 'LIKE', '%'.'produits semi-finis'.'%')
            ->orWhere('name', 'LIKE', '%'.'produit semi-fini'.'%')
            ->get();

        if($dossier->isEmpty() != true){
            $product = Produit_semi_finis::firstOrCreate(
                [ 'nom' => $input['nom'] ],
                [
                    'libelle_commerciale' => $request->libelle_commerciale,
                    // 'famille' => $request->famille,
                    'libelle_legale' =>$request->libelle_legale,
                    'code_becpg' =>$request->code_becpg,
                    'code_erp' => $request->code_erp,
                    'usine_id' => $request->usine_id,
                    'geographique_id' => $request->geographique_id,
                    'dossier_id' => $dossier[0]['id']
                ]
            );

            if($product){
                $produit_fini = Produit_semi_finis::find($product->id);
                DB::table('modele_familles')->insert(
                    ['model_type' => get_class($produit_fini) ,
                     'model_id' => $produit_fini->id,
                     'famille_id' => $input['famille']]
                );
            }
        }else{
            $dossier = Dossiers::firstOrCreate(
                ['name' => 'Produits semi-fini'],
                [
                    'sites_id' => $input['sites_id'],
                    'title' =>
                    'Produits semi-fini', 'parent_id' => 1,
                    'link' => 'http://127.0.0.1:8000/~cosmethnik/admin/dossiers/produitsfini'
                ]
            );

            if($dossier){
                $product = Produit_semi_finis::firstOrCreate(
                    [ 'nom' => $input['nom'] ],
                    [
                        'libelle_commerciale' => $request->libelle_commerciale,
                        // 'famille' => $request->famille,
                        'libelle_legale' =>$request->libelle_legale,
                        'code_becpg' =>$request->code_becpg,
                        'code_erp' => $request->code_erp,
                        'usine_id' => $request->usine_id,
                        'geographique_id' => $request->geographique_id,
                        'dossier_id' => $dossier[0]['id']
                    ]
                );

                if($product){
                    $produit_semi_fini = Produit_semi_finis::find($product->id);
                    DB::table('modele_familles')->insert([
                        'model_type' => get_class($produit_semi_fini) ,
                        'model_id' => $produit_semi_fini->id,
                        'famille_id' => $input['famille']
                        ]
                    );
                }
            }
        }

        if($request->ajax()){
            return ['redirect' => url('dossiers/treeview/'.$request->dossier_id), 'message' => 'success'];
        }
    }

    /**
     * Display the specified Produit_semi_finis.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $produitSemiFinis = $this->produitSemiFinisRepository->find($id);

        if (empty($produitSemiFinis)) {
            Flash::error(__('messages.not_found', ['model' => __('models/produitSemiFinis.singular')]));

            return redirect(route('produitSemiFinis.index'));
        }

        return view('produit_semi_finis.show')->with('produitSemiFinis', $produitSemiFinis);
    }

    /**
     * Show the form for editing the specified Produit_semi_finis.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $produitSemiFinis = $this->produitSemiFinisRepository->find($id);

        if (empty($produitSemiFinis)) {
            Flash::error(__('messages.not_found', ['model' => __('models/produitSemiFinis.singular')]));

            return redirect(route('produitSemiFinis.index'));
        }

        return view('produit_semi_finis.edit')->with('produitSemiFinis', $produitSemiFinis);
    }

    /**
     * Update the specified Produit_semi_finis in storage.
     *
     * @param  int              $id
     * @param UpdateProduit_semi_finisRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProduit_semi_finisRequest $request)
    {
        $produitSemiFinis = $this->produitSemiFinisRepository->find($id);

        if (empty($produitSemiFinis)) {
            Flash::error(__('messages.not_found', ['model' => __('models/produitSemiFinis.singular')]));

            return redirect(route('produitSemiFinis.index'));
        }

        $produitSemiFinis = $this->produitSemiFinisRepository->update($request->all(), $id);

        return json_encode(array("status"=>200));
    }

    /**
     * Remove the specified Produit_semi_finis from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $produitSemiFinis = $this->produitSemiFinisRepository->find($id);

        if (empty($produitSemiFinis)) {
            Flash::error(__('messages.not_found', ['model' => __('models/produitSemiFinis.singular')]));

            return redirect(route('produitSemiFinis.index'));
        }

        $this->produitSemiFinisRepository->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/produitSemiFinis.singular')]));

        return redirect(route('produitSemiFinis.index'));
    }
}

<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Produit_semi_finis
 * @package App\Models
 * @version March 13, 2023, 8:51 pm +07
 *
 * @property string $nom
 * @property string $libelle_commerciale
 * @property string $libelle_legale
 * @property string $description
 * @property string $description_conditionnement
 * @property string $modele
 * @property string $code_becpg
 * @property string $code_erp
 * @property string $ean
 * @property string $ean_colis
 * @property string $ean_palette
 * @property integer $dossier_id
 * @property integer $etat_produit_id
 * @property integer $filiale_id
 * @property integer $usine_id
 * @property integer $geographique_id
 * @property integer $marque_id
 * @property integer $client_id
 * @property integer $unite_id
 * @property integer $quantite_nette
 * @property string $poids_nette_egoutte
 * @property string $freinte_produit
 * @property string $taille_portion
 * @property string $unite_portion
 * @property string $texte_portion
 * @property integer $nombre_portion
 * @property string $cahier_de_charge
 * @property string $date_limite_consommation
 * @property string $ddm_dua
 * @property string $pao
 * @property string $duree_vie_minimum
 * @property integer $condition_conservation_id
 * @property integer $precaution_emploie_id
 * @property string $conseil_preparation_utilisation
 * @property number $prix_vente_uv
 * @property integer $monnaie_id
 * @property integer $quantite_imprevisionnelle
 */
class Produit_semi_finis extends Model
{
    use SoftDeletes;

    public $table = 'produit_semi_finis';

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public $fillable = [
        'nom',
        'libelle_commerciale',
        'libelle_legale',
        'description',
        'description_conditionnement',
        'modele',
        'code_becpg',
        'code_erp',
        'ean',
        'ean_colis',
        'ean_palette',
        'dossier_id',
        'etat_produit_id',
        'filiale_id',
        'usine_id',
        'geographique_id',
        'marque_id',
        'client_id',
        'unite_id',
        'quantite_nette',
        'poids_nette_egoutte',
        'freinte_produit',
        'taille_portion',
        'unite_portion',
        'texte_portion',
        'nombre_portion',
        'cahier_de_charge',
        'date_limite_consommation',
        'ddm_dua',
        'pao',
        'duree_vie_minimum',
        'condition_conservation_id',
        'precaution_emploie_id',
        'conseil_preparation_utilisation',
        'prix_ventxe_uv',
        'monnaie_id',
        'quantite_imprevisionnelle'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nom' => 'string',
        'libelle_commerciale' => 'string',
        'libelle_legale' => 'string',
        'description' => 'string',
        'description_conditionnement' => 'string',
        'modele' => 'string',
        'code_becpg' => 'string',
        'code_erp' => 'string',
        'ean' => 'string',
        'ean_colis' => 'string',
        'ean_palette' => 'string',
        'dossier_id' => 'integer',
        'etat_produit_id' => 'integer',
        'filiale_id' => 'integer',
        'usine_id' => 'integer',
        'geographique_id' => 'integer',
        'marque_id' => 'integer',
        'client_id' => 'integer',
        'unite_id' => 'integer',
        'quantite_nette' => 'integer',
        'poids_nette_egoutte' => 'string',
        'freinte_produit' => 'string',
        'taille_portion' => 'string',
        'unite_portion' => 'string',
        'texte_portion' => 'string',
        'nombre_portion' => 'integer',
        'cahier_de_charge' => 'string',
        'date_limite_consommation' => 'datetime',
        'ddm_dua' => 'datetime',
        'pao' => 'datetime',
        'duree_vie_minimum' => 'datetime',
        'condition_conservation_id' => 'integer',
        'precaution_emploie_id' => 'integer',
        'conseil_preparation_utilisation' => 'string',
        'prix_vente_uv' => 'double',
        'monnaie_id' => 'integer',
        'quantite_imprevisionnelle' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
            'nom'=>'required',
            'libelle_commerciale'=>'required',
            'code_becpg'=>'required',
            'code_erp'=>'required',
            'libelle_legale'=>'required',
    ];

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function dossier()
    {
        return $this->belongsTo(Dossiers::class, 'dossier_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function etat_produit()
    {
        return $this->belongsTo(Etat_produits::class, 'etat_produit_id');
    }

     /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function filiale()
    {
        return $this->belongsTo(Filiales::class, 'filiale_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function usine()
    {
        return $this->belongsTo(Usines::class, 'usine_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function geographique()
    {
        return $this->belongsTo(Geographiques::class, 'geographique_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function marque()
    {
        return $this->belongsTo(Marques::class, 'marque_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    **/
    public function unite()
    {
        return $this->belongsTo(Unites::class, 'unite_id');
    }

    public function monnaie(){
        return $this->belongsTo(Monnaies::class, 'monnaie_id');
    }

    public function precaution_emploie(){
        return $this->belongsTo(Precaution_emploi::class, 'precaution_emploie_id');
    }

    public function condition_conservation(){
        return $this->belongsTo(Condition_conservations::class, 'condition_conservation_id');
    }

    public function commentaires(): MorphMany
    {
        return $this->morphMany(Commentaires::class, 'model');
    }

    public function familles(): MorphMany{
        return $this->morphMany(Familles::class, 'model');
    }

    public function compositions(){
        return $this->morphMany(Compositions::class, 'model');
    }

    public function activites(): MorphMany{
        return $this->morphMany(Activites::class, 'model');
    }
    public function cas_emploies(): MorphMany{
        return $this->morphMany(Cas_emploies::class, 'model');
    }
    public function mmodele_nutriments(){
        return $this->morphMany(Modele_nutriment::class, 'model');
    }
    public function mmodele_emballages(){
        return $this->morphMany(Modele_emballages::class, 'model');
    }
    public function mmodele_ingredients(){
        return $this->morphMany(Modele_ingredients::class, 'model');
    }
    public function mmodele_materiaux(){
        return $this->morphMany(Modele_materiaux::class, 'model');
    }
    public function mmodele_allegations(){
        return $this->morphMany(Modele_allegations::class, 'model');
    }
    public function mmodele_physico_chimiques(){
        return $this->morphMany(Modele_physico_chimique::class, 'model');
    }
    public function mmodele_organoleptiques(){
        return $this->morphMany(Modele_organoleptiques::class, 'model');
    }
    public function mmodele_allergenes(){
        return $this->morphMany(Modele_allergenes::class, 'model');
    }
    public function couts(){
        return $this->morphMany(Couts::class, 'model');
    }
    public function liste_process(){
        return $this->morphMany(Liste_process::class, 'model');
    }

    public function icon() {
        return '<i class="fas fa-flask fa-3x" style="color: coral;"></i>';
    }

    public function icon_accueil() {
        return '<i class="fas fa-flask fa-2x" style="color: coral;"></i>';
    }

    public function icon_menu() {
        return '<i class="fas fa-flask" style="color: coral;"></i>';
    }

    public static $fields = [
        ['menu' => ['props' => 'Propriété', 'link' => 'proprietes.model', 'scripts' => 'propriete']],
        ['menu' => ['props' => 'Fiche technique', 'link' => 'proprietes.model', 'scripts' => 'fiche']],
        ['menu' => ['props' => 'Documents', 'link' => 'fichiers.model', 'scripts' => 'document']],
        ['menu' => ['props' => 'Composition', 'link' => 'compositions.model', 'scripts' => 'composition']],
        ['menu' => ['props' => 'Emballages', 'link' => 'emballages.model', 'scripts' => 'emballage']],
        ['menu' => ['props' => 'Liste des process', 'link' => 'liste_processes.model', 'scripts' => 'process']],
        ['menu' => ['props' => 'Étiquetage', 'link' => 'proprietes.model', 'scripts' => 'etiquetage']],
        ['menu' => ['props' => 'Ingrédients', 'link' => 'ingredients.model', 'scripts' => 'ingredient']],
        ['menu' => ['props' => 'Allergènes', 'link' => 'allergenes.model', 'scripts' => 'allergene']],
        ['menu' => ['props' => 'Coûts', 'link' => 'couts.model', 'scripts' => 'cout']],
        ['menu' => ['props' => 'Nutriments', 'link' => 'nutriments.model', 'scripts' => 'nutriment']],
        ['menu' => ['props' => 'Organoleptique', 'link' => 'proprietes.model', 'scripts' => 'organoleptique']],
        ['menu' => ['props' => 'Physico-chimiques', 'link' => 'physico_chimiques.model', 'scripts' => 'chimique']],
        ['menu' => ['props' => 'Allégations', 'link' => 'allegations.model', 'scripts' => 'allegation']],
        ['menu' => ['props' => 'Cas d\'emplois', 'link' => 'proprietes.model', 'scripts' => 'emploi']],
        ['menu' => ['props' => 'Activités', 'link' => 'proprietes.model', 'scripts' => 'activite']],
        ['menu' => ['props' => 'Matériaux', 'link' => 'materiaux.model', 'scripts' => 'Matériaux']],
        ['menu' => ['props' => 'Organéloptiques', 'link' => 'organeloptique.model', 'scripts' => 'Organéloptiques']],

    ];

}

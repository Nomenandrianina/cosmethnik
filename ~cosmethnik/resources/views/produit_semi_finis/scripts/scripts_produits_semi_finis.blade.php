<script>
        $('.loading-produit-semi-fini').hide();

        $('#link-modal-produit-semi-fini').on('click' , function(e){
            e.preventDefault();
            $('#create_produit_semi_fini').trigger("reset");
            $('#produit-semi-fini-modal').modal('show');
        });

        $('#produit_semi_fini_close').on('click' , function(e){
            e.preventDefault();
            $('#create_produit_semi_fini').trigger("reset");
            $('#produit-semi-fini-modal').modal('hide');
        });

        $(document).on('change','#famille_semi_fini', function() {
            $.ajax({
                url: "{{ route('famille.get_by_famille') }}?idfamille=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $("#sous_famille_semi_fini").html(data.html);
                }
            });
        });

        // Fonction qui enregistre les informations d'un produit semin-finis
        function Store_produit_semi_fini(){
            $('.loading-produit-semi-fini').show();
            let CSRF_TOKEN =  $('meta[name="csrf_token"]').attr('content');
            let nom = $('#nom_semi_fini').val();
            let libelle_commerciale = $('#lib_com_semi_fini').val();
            let famille = $('#famille_semi_fini').val();
            let sous_famille = $('#sous_famille_semi_fini').val();
            let code_becpg = $('#code_becpg_semi_fini').val();
            let code_erp = $('#code_erp_semi_fini').val();
            let etat_produit_id = $('#etat_produit_id_semi_fini').val();
            let usine_id = $('#usine_id_semi_fini').val();
            let geographique_id = $('#geographique_id_semi_fini').val();
            let libelle_legale = $('#lib_leg_semi_fini').val();
            let description = $('#description_semi_fini').val();
            let modele = $('#modele_semi_fini').val();
            let dossier_id = $('#dossier_id').val();
            let sites = $('#sites_id').val();

            $.ajax({
                type:'POST',
                url: "{{ route('produitSemiFinis.store') }}",
                data:{ "_token":"{{ csrf_token() }}",
                    "nom":nom,
                    "libelle_commerciale":libelle_commerciale,
                    "famille":famille,
                    "sous_famille":sous_famille,
                    "code_becpg":code_becpg,
                    "code_erp":code_erp,
                    "etat_produit_id":etat_produit_id,
                    "usine_id":usine_id,
                    "geographique_id":geographique_id,
                    "libelle_legale":libelle_legale,
                    "description":description,
                    "dossier_id":dossier_id,
                    "sites_id":sites
                },
                success: function(data){
                    let timerInterval
                    Swal.fire({
                        title: 'Succèss!',
                        icon: 'success',
                        showConfirmButton:false,
                        html: '<p></p>',
                        timer: 1500,
                        didOpenw: () => {
                            const p = Swal.getHtmlContainer().querySelector('p')
                            timerInterval = setInterval(() => {p.textContent = "Insertion réussie!"}, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                    });
                    location.reload();
                },
                error: function(data){
                    let erros = data.responseJSON;
                    if($.isEmptyObject(erros)== false){
                        console.log('leserreurs',erros.errors);
                        $.each(erros.errors, function(key,value){
                            let ErrorID = '#' + key + 'Error';
                            console.log('text',ErrorID);
                            $(ErrorID).removeClass("d-none");
                            $(ErrorID).text(value)
                        })
                    }
                },
                complete:function(data){
                    $('.loading-produit-semi-fini').hide();
                }
            })
            $("#nomError").addClass('d-none');
        }
</script>

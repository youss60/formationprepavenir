
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">

        <title>jQuery : Uploader une image en AJAX avec un aperçu avant envoi</title>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script>
            $(function () {
                $('#my_form').on('submit', function (e) {
                    // On empêche le navigateur de soumettre le formulaire
                    e.preventDefault();

                    var $form = $(this);
                    var formdata = (window.FormData) ? new FormData($form[0]) : null;
                    var data = (formdata !== null) ? formdata : $form.serialize();

                    $.ajax({
                        url: $form.attr('action'),
                        type: $form.attr('method'),
                        contentType: false, // obligatoire pour de l'upload
                        processData: false, // obligatoire pour de l'upload
                        dataType: 'json', // selon le retour attendu
                        data: data,
                        success: function (response) {
                            $('#result > pre').html(JSON.stringify(response, undefined, 4));
                        }
                    });
                });

                // A change sélection de fichier
                $('#my_form').find('input[name="image"]').on('change', function (e) {
                    var files = $(this)[0].files;

                    if (files.length > 0) {
                        // On part du principe qu'il n'y qu'un seul fichier
                        // étant donné que l'on a pas renseigné l'attribut "multiple"
                        var file = files[0],
                            $image_preview = $('#image_preview');

                        // Ici on injecte les informations recoltées sur le fichier pour l'utilisateur
                        $image_preview.find('.thumbnail').removeClass('hidden');
                        $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
                        $image_preview.find('h4').html(file.name);
                        $image_preview.find('.caption p:first').html(file.size +' bytes');
                    }
                });

                // Bouton "Annuler"
                $('#image_preview').find('button[type="button"]').on('click', function (e) {
                    e.preventDefault();

                    $('#my_form').find('input[name="image"]').val('');
                    $('#image_preview').find('.thumbnail').addClass('hidden');
                });
            });
        </script>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">jQuery : Uploader une image en AJAX avec un aperçu avant envoi</h1>
                </div>
            </div>
			<div class="row">
				<div class="col-lg-6">
					<div id="result">
					</div>
				</div>
			</div>
            <div class="row">
                <div class="col-lg-6">
                    <form id="my_form" class="form-horizontal well" method="post" action="photoajax.php" enctype="multipart/form-data">
                        <fieldset>
                            <legend>Ajouter un article</legend>

                            <div class="form-group">
                                <label for="titre" class="col-lg-2 control-label">Titre</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" id="titre" name="title" placeholder="Titre de l'article">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contenu" class="col-lg-2 control-label">Contenu</label>
                                <div class="col-lg-10">
                                    <textarea class="form-control" rows="3" id="contenu" name="content" placeholder="Contenu de l'article"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contenu" class="col-lg-2 control-label">Illustration</label>
                                <div class="col-lg-10">
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: 0;">
                                <div id="image_preview" class="col-lg-10 col-lg-offset-2">
                                    <div class="thumbnail hidden">
                                        <img src="http://placehold.it/5" alt="">
                                        <div class="caption">
                                            <h4></h4>
                                            <p></p>
                                            <p><button type="button" class="btn btn-default btn-danger">Annuler</button></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Envoyer</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>

                    <div id="result"><pre>Veuillez remplir le formulaire et cliquer sur "Envoyer".</pre></div>
                </div>
            </div>
        </div>
    </body>
</html>

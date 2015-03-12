<?php
/**
 * Created by PhpStorm.
 * User: Aurelien
 * Date: 12/03/15
 * Time: 14:57
 */

include 'template/header.php';
include 'template/menu.php';
include 'listCategory.php';
?>

<div class="container">

    <?php if (isset($_GET['erreur'])) { // TODO:Pour gérer les erreurs. ?>
        <div class="alert alert-dismissable alert-warning">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Une erreur s'est produite !</h4>
            <p>Veuillez réssayer.</p>
        </div>
    <?php } ?>
    <?php if (isset($_GET['category'])) { ?>
        <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4>Catégorie créée aves succès !</h4>
        </div>
    <?php } ?>

    <form class="form-horizontal" action="model/addCategory.php" method="POST">
        <fieldset>
            <legend>Ajouter une catégorie</legend>
            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Nom</label>
                <div class="col-lg-2">
                    <input type="text" class="form-control" name="name" id="name"
                           value="<?php if (isset($_GET['name'])){echo $_GET['name'];}?>"/>
                </div>
            </div>

            <div class="form-group">
                <label for="idParent" class="col-lg-2 control-label">Catégorie parent</label>
                <div class="col-lg-4">
                    <select class="form-control" name="idParent" id="idParent">
                        <option value="0"></option>
                        <?php
                            selectArray($list, $listId, '');
                        ?>
                    </select>
                </div>
            </div>
            <input type="hidden" name="idAdminUser" value="<?php echo $_SESSION['user_id'];?>"/>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
<?php include 'template/footer.php'; ?>
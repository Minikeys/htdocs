<form method="post">

    <?= $form->input('title', 'Titre de l\'article'); ?>

    <?= $form->select('category_id', 'Catégorie', $categories); ?>

    <?= $form->input('content', 'Contenu', ['type' => 'textarea']); ?>

    <button class="btn btn-primary">Sauvegarder</button>

</form>
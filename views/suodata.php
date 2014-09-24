<h2>Luokat</h2>
<form action="suodata.php" method="POST">
    <table class="table">
        <?php foreach($data->luokat as $luokka) : ?>
            <tr> <td><input type="checkbox" name="<?php echo $luokka->get_id() ?>"></td><td>
            <?php echo $luokka->get_nimi() ?></td><td></td></tr> 
        <?php endforeach; ?>
    </table>
    <button class="btn btn-default" type="submit">Suodata</button>
</form>

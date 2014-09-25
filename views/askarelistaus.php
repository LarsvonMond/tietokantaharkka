<div class="btn-group">
    <a href="suodata.php">Suodata</a>
</div>
<div>
    <table class="table">
        <tr> <th>Askare</th><th>Luokat</th><th>Tärkeysaste</th><th></th></tr>  
        <?php foreach($data->askareet as $askare): ?>
            <tr> <td><?php echo $askare->get_kuvaus(); ?> </td> 
            <td>
                <?php foreach($askare->get_luokat() as $luokka): ?>
                    <a href="muokkaa_luokkia.php">
                    <?php echo $luokka; ?>
                    </a>
                <?php endforeach; ?></td>
            <td><?php echo $askare->get_tarkeys(); ?></td>
            <td><a href="muokkaa_askaretta.php?id=<?php echo $askare->get_id(); ?>">
                Muokkaa</a>
            <td>
                <form action="muokkaa_askaretta.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $askare->get_id(); ?>">
                    <input type="hidden" name="delete" value="TRUE">
                    <button class="btn btn-default" type="submit">Poista</button>
                </form>
            </td></tr>
        <?php endforeach; ?>
    </table>
</div>

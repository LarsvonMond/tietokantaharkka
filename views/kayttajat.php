<div>
    <table class="table">
        <tr> <th>Käyttäjätunnus</th><th>Salasana</th><th>Ylläpitäjä</th><th></th></tr>  
        <tr>
            <form action="kayttajat.php" method="POST">
                <td><input type="text" name="kayttajatunnus" placeholder="Uusi käyttäjä" value="<?php echo htmlspecialchars($data->lisattava_kayttaja->get_kayttajatunnus()); ?>"></td>
                <td><input type="text" name="salasana" placeholder="Salasana" value="<?php echo htmlspecialchars($data->lisattava_kayttaja->get_salasana()); ?>"></td>        
                <input type="hidden" name="add" value="TRUE">
                <td><input type="checkbox" name="admin"
                    <?php if ($data->lisattava_kayttaja->get_admin()) : ?>
                        checked
                    <?php endif ; ?></td>
                <td><button class="btn btn-default" type="submit">Lisää</button></td>
            </form>        
            <?php foreach($data->kayttajat as $kayttaja): ?>
            <tr> <td><?php echo htmlspecialchars($kayttaja->get_kayttajatunnus()); ?> </td> 
            <td></td>
            <td>
                <form action="kayttajat.php" method="POST">
                <input type="hidden" name="set_admin" value="TRUE">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($kayttaja->get_id()); ?>">              
                <input type="checkbox" name="admin"
                    <?php if ($kayttaja->get_admin()) : ?>
                        checked
                    <?php endif; ?>>
                </form>            
            </td>
            <td>
                <form action="kayttajat.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($kayttaja->get_id()); ?>">
                    <input type="hidden" name="delete" value="TRUE">
                    <button class="btn btn-default" type="submit">Poista</button>
                </form>
            </td></tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="btn-group">
    <button type="button" class="btn btn-default">
        <a href="suodata.html">Suodata</a>
    </button>
</div>
<div>
    <table class="table">
        <tr> <th>Askare</th><th>Luokat</th><th>Tärkeysaste</th><th></th></tr>  
        <?php foreach($data->askareet as $askare): ?>
            <tr> <td><?php echo $askare->get_kuvaus(); ?> </td> 
            <td><?php foreach($askare->get_luokat() as $luokka): ?>
                    <?php echo $luokka->get_nimi(); ?>
                    <?php echo ', '; ?>
                <?php endforeach; ?></td>
            <td><?php echo $askare->get_tarkeys(); ?></td>
            <td><a href="#">Poista</a></td></tr>
        <?php endforeach; ?>
    </table>
</div>

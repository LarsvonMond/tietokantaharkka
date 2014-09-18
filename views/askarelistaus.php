<div class="btn-group">
    <button type="button" class="btn btn-default">
        <a href="suodata.html">Suodata</a>
    </button>
</div>
<div>
    <table class="table">
        <tr> <th>Askare</th><th>Luokat</th><th>Tärkeysaste</th><th></th></tr>  
        <?php foreach($data->askareet as $askare): ?>
            <tr> <td><?php echo $askare->kuvaus; ?> </td> 
            <td></td>
            <td><?php echo $askare->tarkeys; ?></td>
            <td><a href="#">Poista</a></td></tr>
        <?php endforeach; ?>
    </table>
</div>

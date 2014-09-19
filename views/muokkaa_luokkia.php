<div class="input-group">
    <span class="input-group-addon">Uusi luokka</span>
    <input type="text" class="form-control" placeholder="Luokka">
    <div class="dropdown">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">Yliluokka<span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <?php foreach($data->luokat as $luokka) : ?>
                <li role="presentation"><a href="#">
                    <?php echo $luokka->get_nimi(); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>        
<table class="table">
    <tr> <th></th> <th>Luokka</th><th>Yliluokka</th></tr>
    <?php foreach($data->luokat as $luokka) : ?>
        <tr>
            <td><input type="checkbox"></td>
            <td><?php echo $luokka->get_nimi(); ?></td>
            <td><?php echo $luokka->get_yliluokka_nimi(); ?></td>
        </tr>
    <?php endforeach; ?> 
</table>

<button type="button" class="btn btn-default">
    <a href="#">Tallenna</a>
</button>

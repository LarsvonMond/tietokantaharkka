<h1>Lisää askare</h1>
    <form action="lisaa_askare.php" method="POST">
        <input type="text" class="form-control" name="kuvaus" placeholder="Askare">
    <h3>Tärkeys<h3>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys">1</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys">2</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys">3</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys">4</label>
    </div>
    <div class="radio">
        <label>
        <input type="radio" name="tarkeys">5</label>
    </div>

    <h2>Luokat</h2>
    <table class="table">
            <tr> <td>Uusi luokka</td><td><input type="text" class="form-control" placeholder="Luokka"></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">Yliluokka<span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                            <?php foreach($data->luokat as $luokka) : ?>
                                <li role="presentation"><a href="#">
                                    <?php echo $luokka->get_nimi() ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </td>
            </tr>
            <?php foreach($data->luokat as $luokka) : ?>
                <tr> <td><input type="checkbox" name="<?php echo $luokka->get_id(); ?>"></td><td>
                <?php echo $luokka->get_nimi() ?></td><td></td></tr> 
            <?php endforeach; ?>
    </table>
    <button class="btn btn-default" type="submit">Lisää</button>
    </form>

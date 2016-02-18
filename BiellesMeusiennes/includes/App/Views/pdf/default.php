<page  backright="25%" backtop="25%" >
    <page_header>
       Je suis le header dans la page includes/App/Views/pdf/default
    </page_header>
    <page_footer>
        ...
    </page_footer>
    <nobreak>
    <table cellspacing="10" style="font-size: 10px">
        <thead>
            <tr>
                <th>id</th>
                <th>firstname</th>
                <th>lastname</th>
                <th>type</th>
                <th>email</th>
                <th>adress1</th>
                <th>adress2</th>
                <th>adress3</th>
                <th>city</th>
                <th>cp</th>
                <th>cedex</th>
                <th>country</th>               
                <th>newsletter</th>
                <th>club</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($datas as $data) : ?>

            <tr>
                <td><?= $data->id;?></td>
                <td><?= $data->firstname;?></td>
                <td><?= $data->lastname;?></td>
                <td><?= $data->type;?></td>
                <td><?= $data->email;?></td>
                <td><?= $data->adress1;?></td>
                <td><?= $data->adress2;?></td>
                <td><?= $data->adress3;?></td>
                <td><?= $data->city;?></td>
                <td><?= $data->cp;?></td>
                <td><?= $data->cedex;?></td>
                <td><?= $data->country;?></td>
                <td><?= $data->newsletter;?></td>
                <td><?= $data->club;?></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
</nobreak>
</page>

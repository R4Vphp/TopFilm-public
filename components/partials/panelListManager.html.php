<?php
use App\Model\List\Manager;
?>
<div class='panel'>
    <form-hooks>
        <form id="list-create" action="/list-create" method="post"></form>
    </form-hooks>
    <h2>Lists <span>(<?= Manager::get()->listAmount(); ?>)</span></h2>
    <div class="content limit">
        <?php Manager::get()->printAsPanel(); ?>
    </div>
    <div class="content">
        <hr>
        <table>
            <tr>
                <td><p class="details"><span>New list:</span></p></td>
                <td><input form="list-create" class="inputField" name="listTitle" type="text" placeholder="TITLE" /></td>
                <td><button form="list-create" type="submit" class="standardButton" name="createList">Create</button></td>
            </tr>
        </table>
    </div>
</div>

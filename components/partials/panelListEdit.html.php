<div class='panel'>
    <h2>List Editor</h2>
    <div class='content'>
        <form action="includes/renameList.inc,php" method="post">
            <input type="hidden" value="<?= $list[$_GET[0] ?? 0]->getListId(); ?>">
            <table>
                <tr>
                    <td><p class="details"><span>Title:</span></p></td>
                    <td><input class="inputField" name="title" type="text" value="<?= $list[$_GET[0] ?? 0]->getTitle(); ?>" /></td>
                    <td><button type="submit" class="standardButton" name="rename">Rename</button></td>
                </tr>
            </table>
        </form>
        <hr>
        <form action="includes/renameList.inc,php" method="post">
            <input type="hidden" value="<?= $list[$_GET[0] ?? 0]->getListId(); ?>">
            <table>
                <tr>
                    <td><button type="submit" class="standardButton" name="DROP">Delete</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>
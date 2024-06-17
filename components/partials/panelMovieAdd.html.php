<div class="panel">
    <form-hooks>
        <form id="upload" action="/movie-upload" method="post"></form>
    </form-hooks>
    <h2>New movie</h2>
    <div class="content">
        <table>
            <tr>
                <td><p class="details"><span>Filmweb link:</span></p></td>
                <td><input form="upload" class="inputField" name="filmWebLink" type="text" placeholder=".../film/TITLE-YEAR-ID" /></td>
                <td><button form="upload" type="submit" class="standardButton" name="createList">Upload</button></td>
            </tr>
        </table>
    </div>
</div>
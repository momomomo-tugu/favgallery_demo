const deleteButton = document.getElementById('deleteButton');

deleteButton.submit = function() {
    ret = confirm('本当に削除しますか？');
    if (ret == true) {
        // location.href = "../items_controller/items_delete.php";
        return true;
    }
}
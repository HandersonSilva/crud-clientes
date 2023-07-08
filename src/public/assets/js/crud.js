function deleteCliente(url) {
    let token = document.getElementsByName("_token")[0].value;

    if (confirm("Deseja realmente excluir o registro?")) {
        let ajax = new XMLHttpRequest();
        ajax.open("DELETE", url);
        ajax.setRequestHeader("X-CSRF-TOKEN", token);
        ajax.onreadystatechange = function () {
            if (ajax.readyState === 4 && ajax.status === 200) {
                location.reload();
            }
        };

        ajax.send();
    } else {
        return false;
    }
}

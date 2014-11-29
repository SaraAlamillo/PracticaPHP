function cambiarPagina(action) {
    var pagina = document.getElementById("paginaBuscada").value;
    var url = "index.php?action=" + action + "&pagina=" + pagina;
    document.location.href = url;
}
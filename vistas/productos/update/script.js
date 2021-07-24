document.getElementById('CategoriasList').addEventListener("click",(e)=>{
    if(e.target.matches(".btnEdit *")){
        let item = e.target.closest(".btnEdit");
        document.getElementById('formAddCategoria')[0].value = item.getAttribute("data-value");
        document.getElementById('formAddCategoria')[1].value = item.getAttribute("data-description");
        document.getElementById('formAddCategoria')[2].value = item.getAttribute("data-id");
        document.getElementById('formAddCategoria')[3].innerHTML = "Actualizar " + item.getAttribute("data-id");

    }
})

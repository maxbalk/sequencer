function navigate(route){
    let form = document.forms[0];
    //form.method = "post";
    form.action = "/";
    form.elements[0].value = route;
    form.submit();
}
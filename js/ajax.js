function getHP(select, field, page){
    const ID = select.value;
    let requestInfo = new XMLHttpRequest();
    requestInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        s = "<option value=''>Chọn học phần</option>";
        const infor = JSON.parse(this.response); 
        for (var i = 0; i < infor.length; i++) {
            var object = infor[i];
            s += "<option value='"+object.MAHP+"'>"+object.TENHP+"</option>";
        }
        document.getElementById("hocphan").innerHTML = s;
    }}
    URL = page+"?"+field+"=";
    requestInfo.open("GET", URL + ID);
    requestInfo.send();
}

function getNHP(select, field, page){
    const ID = select.value;
    let requestInfo = new XMLHttpRequest();
    requestInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        s = "<option value=''>Chọn học phần</option>";
        console.log(this.response);
        const infor = JSON.parse(this.response); 
        for (var i = 0; i < infor.length; i++) {
            var object = infor[i];
            s += "<option value='"+object.MANHOMHP+"'>"+object.MANHOMHP+"</option>";
        }
        document.getElementById("lophp").innerHTML = s;
    }}
    URL = page+"?"+field+"=";
    requestInfo.open("GET", URL + ID);
    requestInfo.send();
}

function changeData(idform, pagesever) {
    const form = document.getElementById(idform);
    const elements = form.elements;

    let isEmpty = false;

    for (let i = 0; i < elements.length; i++) {
        const element = elements[i];

        if (element.tagName === 'INPUT' || element.tagName === 'SELECT') {
            if (element.value.trim() === '') {
                isEmpty = true;
                break;
            }
        }
    }
    if (isEmpty) {
        alert('Vui lòng điền đầy đủ thông tin');
    } else {
        var formData = new FormData(document.getElementById(idform));
        var request = new XMLHttpRequest();
        console.log(formData);
        request.onreadystatechange = function() {
            console.log(this.reponse);
            if (request.readyState == XMLHttpRequest.DONE) {
                if (request.status == 200) {
                    console.log("Successfully change data");
                    window.location.reload(true);
                    
                } else {
                    console.error('Failed to change data');
                }
            }
        };

        request.open("POST", pagesever, true);
        request.send(formData);


        var modal = document.getElementById('addinfor');
        modal.style.display = 'none';
    } 
}

function updateForm(button){
    const ID = button.value;
    let requestProductInfo = new XMLHttpRequest();
    requestProductInfo.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
        const information = JSON.parse(this.response); 
        document.getElementById("start").value = moment(new Date(Number(information[0]["NGAYBD"]["$date"]["$numberLong"]))).format('YYYY-MM-DD');
        document.getElementById("end").value = moment(new Date(Number(information[0]["NGAYKT"]["$date"]["$numberLong"]))).format('YYYY-MM-DD');
        if(information[0]["MAGV"] != null){
            var mySelect = document.getElementById("giangvien");
            var option = mySelect.querySelector("option[value='"+information[0]["MAGV"]+"']");
            option.selected = true;
        }else{
            var mySelect = document.getElementById("giangvien");
            var option = mySelect.querySelector("option[value='']");
            option.selected = true;
        }
        document.getElementById("MANHOMHP").value = information[0]["MANHOMHP"];
        document.getElementById("stt").innerHTML = "Nhóm " + information[0]["MANHOMHP"]

    }
}
requestProductInfo.open("GET", "i4-nhomhocphan.php?MANHOMHP=" + ID);
requestProductInfo.send();
}
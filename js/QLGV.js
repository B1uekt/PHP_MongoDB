function UpdateGV(button){
    const ID = button.value;
    //console.log(ID);
    let requestGVInfo = new XMLHttpRequest();
    requestGVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.response);
    const GV = JSON.parse(this.response);  
    document.getElementById("name").value = GV["TENGV"];
    document.getElementById("email").value = GV["EMAIL"];
    document.getElementById("phone").value = GV["SDT"];
    document.getElementById("status").value = GV["TRANGTHAI"];
    document.getElementById("khoa").value = GV["MajorName"];
    }
}
requestGVInfo.open("POST", "i4GV.php?MaGV=" + ID);
requestGVInfo.send();
}

function redirectToUpdatePage(magv) {
    // Chuyển đến trang cần thiết với thông tin cần thiết
    window.location.href = 'detail_page.php?magv=' + magv;
}

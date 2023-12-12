function UpdateClass(button){
    const ID = button.value;

    let requestGVInfo = new XMLHttpRequest();
    requestGVInfo.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
        console.log(this.response);
    const CLASS = JSON.parse(this.response);  
    document.getElementById("malop").value = CLASS["MALOP"];
    document.getElementById("nameClass").value = CLASS["TENLOP"];
    document.getElementById("branch").value = CLASS["TENNGANH"];
    document.getElementById("nameCV").value = CLASS["TENCOVAN"];
    document.getElementById("nienkhoa").value = CLASS["TENNIENKHOA"];
    }
}
requestGVInfo.open("POST", "i4Class.php?MaClass=" + ID);
requestGVInfo.send();
}
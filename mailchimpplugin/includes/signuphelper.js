function signup(formactionid, responseid) {
    var URL = document.getElementById('mcformaction').value;
    var data = {};
    data.mclistid = document.getElementById('mclistid').value;
    data.mcemail = document.getElementById('mcemail').value;
    data.mcfname = document.getElementById('mcfname').value;
    data.mclname = document.getElementById('mclname').value;

    if (!data.mclistid || !data.mcemail || !data.mcfname || !data.mclname) {
        document.getElementById('mcresponseinfo').innerHTML = "Udfyld venligst alle felter.";
        return;
    } else {
        var xmlHttpReq = false;
        var self = this;
    
        self.xmlHttpReq = new XMLHttpRequest();
    
        self.xmlHttpReq.open('POST', URL, true);
        self.xmlHttpReq.setRequestHeader('Content-Type', 'application/json');
        self.xmlHttpReq.onreadystatechange = function() {
            if (self.xmlHttpReq.readyState == 4) {
                document.getElementById('mcresponseinfo').innerHTML = self.xmlHttpReq.responseText;
            }
        }
        self.xmlHttpReq.send(JSON.stringify(data));
    }
}


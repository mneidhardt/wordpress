function signon() {
    var URL = document.getElementById('mcformactionon').value;
    var data = {};
    data.mclistid = document.getElementById('mclistid').value;
    data.mcemail = document.getElementById('mcemail').value;
    data.mcfname = document.getElementById('mcfname').value;
    data.mclname = document.getElementById('mclname').value;

    if (!data.mclistid || !data.mcemail || !data.mcfname || !data.mclname) {
        document.getElementById('mcresponseinfo').innerHTML = "Udfyld venligst alle felter.";
        return;
    } else {
        doit(URL, data);
    }
}

function signoff() {
    var URL = document.getElementById('mcformactionoff').value;
    var data = {};
    data.mclistid = document.getElementById('mclistid').value;
    data.mcemail = document.getElementById('mcemail').value;

    if (!data.mclistid || !data.mcemail) {
        document.getElementById('mcresponseinfo').innerHTML = "Udfyld venligst både liste og email.";
        return;
    } else {
        doit(URL, data);
    }
}


function doit(URL, data) {
    var xmlHttpReq = false;
    var self = this;
    document.getElementById('mcresponseinfo').innerHTML = 'Vent venligst...';
    
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


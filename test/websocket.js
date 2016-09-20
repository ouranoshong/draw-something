var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
    conn.send("亲爱的服务器！我连上你啦！");
};

conn.onmessage = function(e) {
    console.log(e.data);
};



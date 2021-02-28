const criticalCss = require('./critical-css');
const express = require('express');

// Constants
const PORT = 8080;
const HOST = '0.0.0.0';

// App
const app = express();
app.get('/', (req, res) => {
    res.type('text/css');
    criticalCss.generateCriticalCSS().then((generatedCriticalCss) => {
        res.send(generatedCriticalCss);
    });
});

app.listen(PORT, HOST);
console.log(`Running on http://${HOST}:${PORT}`);

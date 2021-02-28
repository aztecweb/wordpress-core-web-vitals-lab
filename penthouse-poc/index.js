const criticalCss = require('./critical-css');

criticalCss.generateCriticalCSS().then((generatedCriticalCss) => {
    console.log(generatedCriticalCss);
});

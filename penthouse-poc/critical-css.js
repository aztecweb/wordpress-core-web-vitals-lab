const puppeteer = require('puppeteer')
const penthouse = require('penthouse')

// Based on https://github.com/pocketjoso/penthouse/issues/311
function launchBrowser() {
    const browser = puppeteer.launch({
        args: [
            '--no-sandbox',
            '--disable-setuid-sandbox',
            '--disable-dev-shm-usage',
            '--window-size=1920,1200',
        ],
        defaultViewport: {
            width: 1920,
            height: 1200,
        },
    });

    return browser;
}

// Based on https://github.com/pocketjoso/penthouse#basic-example
exports.generateCriticalCSS = () => {
    const criticalCss = penthouse({
        url: 'http://static-server/index.html',
        css: '/penthouse-poc/style.css',
        puppeteer: {
            getBrowser: () => launchBrowser(),
        }
    });

    return criticalCss;
}

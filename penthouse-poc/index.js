const puppeteer = require('puppeteer')
const penthouse = require('penthouse')

// Based on https://github.com/pocketjoso/penthouse/issues/311
browser = puppeteer.launch({
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
})

// Based on https://github.com/pocketjoso/penthouse#basic-example
penthouse({
    url: 'http://static-server/index.html',
    css: '/penthouse-poc/style.css',
    puppeteer: {
        getBrowser: () => browser,
    }
}).then(criticalCss => {
    console.log(criticalCss)
})

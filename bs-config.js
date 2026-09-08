const proxyTarget = process.env.PROXY_TARGET || 'http://kirby-starter.test';

module.exports = {
  proxy: proxyTarget,
  files: [
    {
      match: ['public/assets/css/*.css'],
      fn: function (event, file) {
        this.reload({ stream: true });
      },
    },
    {
      match: [
        'site/**/*.php',
        'site/**/*.json',
        'public/content/**/*.txt',
        'public/content/**/*.json',
      ],
      fn: function (event, file) {
        this.sockets.emit('php:morph', { file });
      },
    },
    {
      match: ['public/assets/js/app.dist.js'],
      fn: function (event, file) {
        this.reload();
      },
    },
  ],
  injectChanges: true,
  cors: true,
  notify: false,
  open: false,
  ghostMode: false,
  reloadDelay: 100,
  socket: {
    domain: 'localhost:3000',
  },
};

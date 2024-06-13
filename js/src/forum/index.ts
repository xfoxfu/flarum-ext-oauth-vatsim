import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import SignUpModal from 'flarum/forum/components/SignUpModal';
import Stream from 'flarum/common/utils/Stream';

app.initializers.add('vatprc/oauth-vatsim', () => {
  console.log('vatprc auth-vatsim loaded');

  extend(SignUpModal.prototype, 'fields', function (items) {
    console.log(items.get('username'));
    console.log(items.get('email'));
    console.log(this.attrs);
  });

  extend(SignUpModal.prototype, 'oninit', function () {
    if ('nickname' in this) {
      (this.nickname as ReturnType<Stream>)(this.attrs.nickname || '');
    }
  });
});

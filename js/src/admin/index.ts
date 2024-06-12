import app from 'flarum/admin/app';
import { ConfigureWithOAuthPage } from '@fof-oauth';

app.initializers.add('xfoxfu/oauth-vatsim', () => {
  app.extensionData.for('xfoxfu-oauth-vatsim').registerPage(ConfigureWithOAuthPage);
});

import app from 'flarum/admin/app';
import { ConfigureWithOAuthPage } from '@fof-oauth';

app.initializers.add('vatprc/oauth-vatsim', () => {
  app.extensionData.for('vatprc-oauth-vatsim').registerPage(ConfigureWithOAuthPage);
});

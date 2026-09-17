const { writeOutput, versions } = require('./lib.js');

try {
  const v = versions();
  if (v.synced) {
    writeOutput({});
    process.exit(0);
  }

  writeOutput({
    followup_message:
      'Версии не синхронны: xml=' +
      v.manifest +
      ' php=' +
      v.asset +
      ' update.xml=' +
      v.update +
      (v.urlOk ? '' : ' (downloadurl не содержит версию)') +
      '. Выровняй по .cursor/skills/joomla-5-6/versions.md, не поднимая номер без нужды.',
  });
} catch {
  writeOutput({});
}

const fs = require('fs');
const path = require('path');

function readInput() {
  try {
    const raw = fs.readFileSync(0, 'utf8').trim();
    return raw ? JSON.parse(raw) : {};
  } catch {
    return {};
  }
}

function writeOutput(obj) {
  process.stdout.write(JSON.stringify(obj));
}

function repoRoot() {
  return path.resolve(__dirname, '..', '..');
}

function readRepoFile(rel) {
  return fs.readFileSync(path.join(repoRoot(), rel), 'utf8');
}

function versions() {
  const xml = readRepoFile('mod_bsr_form.xml');
  const php = readRepoFile('mod_bsr_form.php');
  const upd = readRepoFile('update.xml');
  const manifest = (xml.match(/<version>([^<]+)<\/version>/) || [])[1] || '';
  const asset = (php.match(/\$assetVersion\s*=\s*'([^']+)'/) || [])[1] || '';
  const update = (upd.match(/<version>([^<]+)<\/version>/) || [])[1] || '';
  const url = (upd.match(/<downloadurl[^>]*>([^<]+)<\/downloadurl>/) || [])[1] || '';
  const urlOk = !update || url.includes('v' + update) && url.includes(update);
  return { manifest, asset, update, url, urlOk, synced: manifest && manifest === asset && asset === update && urlOk };
}

module.exports = { readInput, writeOutput, repoRoot, readRepoFile, versions };

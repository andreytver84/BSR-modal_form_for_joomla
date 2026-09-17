const { readInput, writeOutput } = require('./lib.js');

const input = readInput();
const toolInput = input.tool_input || {};
const filePath = String(toolInput.path || toolInput.file_path || '');
const norm = filePath.replace(/\\/g, '/').toLowerCase();

const hints = [];

if (/(^|\/)language\/.+\.ini$/.test(norm)) {
  hints.push('Языки: те же ключи в ru-RU и en-GB; .ini ≠ .sys.ini. См. .cursor/skills/joomla-5-6/language.md');
}

if (/mod_bsr_form\.xml$/.test(norm) || /(^|\/)update\.xml$/.test(norm)) {
  hints.push('XML: версия = php $assetVersion = update.xml + downloadurl. Description без <script>.');
}

if (/mod_bsr_form\.php$/.test(norm) || /(^|\/)tmpl\/.+\.php$/.test(norm)) {
  hints.push('PHP/tmpl: _JEXEC, htmlspecialchars ENT_QUOTES UTF-8, переиспользовать bsrSanitize*.');
}

if (/(^|\/)assets\/js\/script\.js$/.test(norm)) {
  hints.push('JS: не ослаблять isSafeRedirect, не трогать imask.min.js.');
}

if (hints.length) {
  writeOutput({ additional_context: hints.join(' ') });
} else {
  writeOutput({});
}

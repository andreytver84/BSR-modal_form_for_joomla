const { readInput, writeOutput } = require('./lib.js');

const input = readInput();
const filePath = String(input.file_path || '').replace(/\\/g, '/').toLowerCase();

if (filePath.endsWith('imask.min.js')) {
  writeOutput({
    permission: 'deny',
    user_message: 'imask.min.js — вендорный минифицированный файл, в контекст не читаем.',
  });
} else {
  writeOutput({ permission: 'allow' });
}

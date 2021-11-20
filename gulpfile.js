// Определяем переменную "preprocessor"
let preprocessor = 'sass'
let preprocessorType = 'scss'
// Определяем константы Gulp
const { src, dest, parallel, series, watch } = require('gulp')
const browserSync = require('browser-sync').create()
const concat = require('gulp-concat')
const uglify = require('gulp-uglify-es').default
const sass = require('gulp-sass')
const autoprefixer = require('gulp-autoprefixer')
const cleancss = require('gulp-clean-css')
const imagemin = require('gulp-imagemin')
const newer = require('gulp-newer')
const del = require('del')
const webp = require('gulp-webp')
const webpHTML = require('gulp-webp-html')
const fileinclude = require('gulp-file-include')
const gulp = require('gulp')
const ttf2Woff = require('gulp-ttf2woff')
const ttf2Woff2 = require('gulp-ttf2woff2')
const fonter = require('gulp-fonter')

// Определяем логику работы Browsersync
function browsersync() {
	browserSync.init({
		// Инициализация Browsersync
		server: { baseDir: 'dist/' }, // Указываем папку сервера
		notify: false, // Отключаем уведомления
		online: true, // Режим работы: true или false
	})
}

// Упаковываем img в тег <picture>
function html() {
	return src(['app/**/*.html', '!' + 'app/**/_*.html'])
		.pipe(
			fileinclude({
				prefix: '@@',
				basepath: '@file',
			})
		)

		.pipe(webpHTML())
		.pipe(dest('dist/')) // Выгрузим результат в папку "dist/"
		.pipe(browserSync.stream()) // Сделаем инъекцию в браузер
}

function video() {
	return src('app/video/**/*').pipe(dest('dist/video/')) // Выгрузим в папку "dist/"
}

function php() {
	return src(
		[
			// Выбираем нужные файлы
			'app/*.php',
			'app/phpmailer/*.php',
		],
		{ base: 'app' }
	) // Параметр "base" сохраняет структуру проекта при копировании
		.pipe(dest('dist')) // Выгружаем в папку с финальной сборкой
}

function scripts() {
	return src([
		// Берём файлы из источников
		'node_modules/jquery/dist/jquery.min.js', // Пример подключения библиотеки
		'app/js/*.js', // Пользовательские скрипты
	])
		.pipe(concat('app.min.js')) // Конкатенируем в один файл
		.pipe(uglify()) // Сжимаем JavaScript
		.pipe(dest('dist/js/')) // Выгружаем готовый файл в папку назначения
		.pipe(browserSync.stream()) // Триггерим Browsersync для обновления страницы
}

function styles() {
	return src('app/' + preprocessor + '/main.' + preprocessorType + '') // Выбираем источник: "app/sass/main.sass" или "app/less/main.less"
		.pipe(eval(preprocessor)()) // Преобразуем значение переменной "preprocessor" в функцию
		.pipe(concat('app.min.css')) // Конкатенируем в файл app.min.js
		.pipe(autoprefixer({ overrideBrowserslist: ['last 10 versions'], grid: true })) // Создадим префиксы с помощью Autoprefixer
		.pipe(cleancss({ level: { 1: { specialComments: 0 } }, format: 'beautify' })) // Минифицируем стили
		.pipe(dest('dist/css/')) // Выгрузим результат в папку "app/css/"
		.pipe(browserSync.stream()) // Триггерим Browsersync для обновления страницы
}

function images() {
	return src('app/images/**/*') // Берём все изображения из папки источника
		.pipe(newer('dist/images/')) // Проверяем, было ли изменено (сжато) изображение ранее
		.pipe(imagemin()) // Сжимаем и оптимизируем изображеня
		.pipe(dest('dist/images/')) // Выгружаем оптимизированные изображения в папку назначения
		.pipe(src('dist/images/**/*')) // Берём все изображения из папки источника
		.pipe(webp({})) // Конвертируем в WEBP изображеня
		.pipe(dest('dist/images/')) // Выгружаем WEBP изображения в папку назначения
}

function icon() {
	return src('app/*.ico') // Берём все ICO из папки источника
		.pipe(dest('dist/')) // Выгружаем изображения в папку назначения
}

function cleanimg() {
	return del('app/images/dest/**/*', { force: true }) // Удаляем всё содержимое папки "app/images/dest/"
}

function buildcopy() {
	return src(
		[
			// Выбираем нужные файлы
			'app/css/**/*.min.css',
			'app/js/**/*.min.js',
			'app/images/dest/**/*',
			'app/**/*.html',
		],
		{ base: 'app' }
	) // Параметр "base" сохраняет структуру проекта при копировании
		.pipe(dest('dist')) // Выгружаем в папку с финальной сборкой
}

function cleandist() {
	return del('dist/**/*', { force: true }) // Удаляем всё содержимое папки "dist/"
}

function cleanfonts() {
	return del('dist/fonts/', { force: true }) // Удаляем всё содержимое папки "dist/fonts/"
}

function startwatch() {
	// Выбираем все файлы JS в проекте, а затем исключим с суффиксом .min.js
	watch(['app/**/*.js', '!app/**/*.min.js'], scripts)
	// Мониторим файлы препроцессора на изменения
	watch('app/**/' + preprocessor + '/**/*', styles)
	// Мониторим файлы HTML на изменения
	watch('app/**/*.html').on('change', html)
	// Мониторим папку-источник изображений и выполняем images(), если есть изменения
	watch('app/images/**/*', images)
	// Мониторим папку-источник изображений и выполняем images(), если есть изменения
	watch('app/images/**/*', icon)
}

// Подключаем модуль шрифтов
function ttf2woff() {
	src(['app/fonts/fonts_text/*.ttf']).pipe(ttf2Woff()).pipe(dest('dist/fonts/fonts_text/'))
	return src(['app/fonts/fonts_text/*.ttf']).pipe(ttf2Woff2()).pipe(dest('dist/fonts/fonts_text/'))
}

function otf2ttf() {
	return src(['app/fonts/fonts_text/*.otf'])
		.pipe(
			fonter({
				formats: ['ttf'],
			})
		)
		.pipe(dest('app/fonts/fonts_text/'))
}

function fonts_icon() {
	return src(['app/fonts/fonts_icon/*']).pipe(dest('dist/fonts/fonts_icon/'))
}

exports.browsersync = browsersync
exports.scripts = scripts
exports.styles = styles
exports.images = images
exports.icon = icon
exports.cleanimg = cleanimg
exports.ttf = series(cleanfonts, otf2ttf, ttf2woff)
exports.html = html
exports.video = video
exports.php = php
exports.build = series(cleandist, styles, scripts, images, buildcopy)
exports.default = parallel(styles, scripts, images, icon, series(cleanfonts, otf2ttf, ttf2woff, fonts_icon), video, html, php, browsersync, startwatch)

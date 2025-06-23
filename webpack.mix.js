// webpack.mix.js
process.env.DISABLE_NOTIFIER = true;

import laravelMix from 'laravel-mix';
import tailwindcss from 'tailwindcss';
import autoprefixer from 'autoprefixer';

const mix = laravelMix; // laravelMixをmixとしてエイリアス設定

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
        tailwindcss, // インポートしたtailwindcssを使用
        autoprefixer, // インポートしたautoprefixerを使用
   ]);

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/questions.js',
                'resources/js/sortQuestions.js',
                'resources/js/adminFilterByUsername.js',
                'resources/js/welcome.js',
                'resources/js/quiz.js',
                'resources/js/showQuestion.js',
            ],
            refresh: true,
        }),
    ],
});

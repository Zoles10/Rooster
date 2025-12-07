import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        cors: true,
        hmr: {
            host: 'localhost',
            protocol: 'ws',
            port: 5175,
            cors: true
        },
        watch: {
            usePolling: true,
        },
    },
    plugins: [
        laravel({
                input: [
                    'resources/css/app.css',
                    'resources/js/app.js',
                    'resources/js/questions.js',
                    'resources/js/sortQuestions.js',
                    'resources/js/questionCreate.js',
                    'resources/js/questionEdit.js',
                    'resources/js/adminFilterByUsername.js',
                    'resources/js/welcome.js',
                    'resources/js/quiz.js',
                    'resources/js/showQuestion.js',
                    'resources/js/createQuiz.js',
                    'resources/js/questionEdit.js',
                    'resources/js/answersShow.js',
                ],
            refresh: true,
        }),
    ],
});

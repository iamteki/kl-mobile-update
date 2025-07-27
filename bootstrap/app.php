<?php

// bootstrap/app.php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // Handle 404 errors with custom page
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            
            // Log the 404 for analytics (optional)
            \Log::info('404 Error', [
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
                'referer' => $request->header('referer'),
            ]);

            // Check if it's an API request
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'error' => 'Not Found',
                    'message' => 'The requested resource was not found.',
                    'status_code' => 404
                ], 404);
            }

            // Check if it's a Filament admin request
            if ($request->is('admin/*')) {
                return response()->view('errors.admin-404', [], 404);
            }

            // Return custom 404 page for frontend
            return response()->view('errors.404', [
                'exception' => $e,
                'request' => $request
            ], 404);
        });

        // Handle 403 Forbidden errors
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403) {
                
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'error' => 'Forbidden',
                        'message' => 'You do not have permission to access this resource.',
                        'status_code' => 403
                    ], 403);
                }

                return response()->view('errors.403', [
                    'exception' => $e,
                    'request' => $request
                ], 403);
            }
        });

        // Handle 500 Internal Server Error
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 500) {
                
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'error' => 'Internal Server Error',
                        'message' => 'An internal server error occurred.',
                        'status_code' => 500
                    ], 500);
                }

                return response()->view('errors.500', [
                    'exception' => $e,
                    'request' => $request
                ], 500);
            }
        });

        // Handle 503 Service Unavailable
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 503) {
                
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'error' => 'Service Unavailable',
                        'message' => 'The service is temporarily unavailable.',
                        'status_code' => 503
                    ], 503);
                }

                return response()->view('errors.503', [
                    'exception' => $e,
                    'request' => $request
                ], 503);
            }
        });

    })->create();
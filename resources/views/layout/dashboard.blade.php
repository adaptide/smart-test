<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        border: 'hsl(214.3 31.8% 91.4%)',
                        input: 'hsl(214.3 31.8% 91.4%)',
                        ring: 'hsl(221.2 83.2% 53.3%)',
                        background: 'hsl(0 0% 100%)',
                        foreground: 'hsl(222.2 84% 4.9%)',
                        primary: {
                            DEFAULT: 'hsl(221.2 83.2% 53.3%)',
                            foreground: 'hsl(210 40% 98%)',
                        },
                        secondary: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(222.2 47.4% 11.2%)',
                        },
                        muted: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(215.4 16.3% 46.9%)',
                        },
                        accent: {
                            DEFAULT: 'hsl(210 40% 96.1%)',
                            foreground: 'hsl(222.2 47.4% 11.2%)',
                        },
                    },
                    borderRadius: {
                        lg: '0.5rem',
                        md: '0.375rem',
                        sm: '0.25rem',
                    },
                }
            }
        }
    </script>
</head>
        @yield('content')
</html>
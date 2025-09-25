import { NextResponse } from 'next/server'
import type { NextRequest } from 'next/server'

export function middleware(request: NextRequest) {

  const path = request.nextUrl.pathname

  const isProtectedPath = path.startsWith('/dashboard') || 
                         path.startsWith('/schedule-pickup') || 
                         path.startsWith('/recycling-guide') ||
                         path === '/profile'

 
  const isAuthPath = path === '/login' || path === '/signup'

 
  if (path.startsWith('/api') || path.startsWith('/_next') || path.includes('.')) {
    return NextResponse.next()
  }

  const accessToken = request.cookies.get('sb-access-token')
  const refreshToken = request.cookies.get('sb-refresh-token')
  
  
  const hasValidSession = accessToken && refreshToken

  // If trying to access protected route without auth, redirect to login
  if (isProtectedPath && !hasValidSession) {
    const loginUrl = new URL('/login', request.url)
    loginUrl.searchParams.set('redirect', path)
    return NextResponse.redirect(loginUrl)
  }

  // If trying to access auth pages while already authenticated, redirect to dashboard
  if (isAuthPath && hasValidSession) {
    return NextResponse.redirect(new URL('/dashboard', request.url))
  }

  return NextResponse.next()
}

export const config = {
  matcher: [
    /*
     * Match all request paths except for the ones starting with:
     * - api (API routes)
     * - _next/static (static files)
     * - _next/image (image optimization files)
     * - favicon.ico (favicon file)
     * - public folder
     */
    '/((?!api|_next/static|_next/image|favicon.ico|.*\\.(?:svg|png|jpg|jpeg|gif|webp)$).*)',
  ],
}

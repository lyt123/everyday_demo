package com.ivanlin.hmacauth;

import org.springframework.web.servlet.handler.HandlerInterceptorAdapter;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

public abstract class HmacAuthInterceptor extends HandlerInterceptorAdapter {

    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws IOException {
        HmacAuthService authService = new HmacAuthService(request, response);

        String secretKey;
        try {
            secretKey = getAccountSecretKey(authService.getRequestAccountName());
        } catch (Throwable throwable) {
            authService.getAccountSecretKeyFailed(throwable);
            return false;
        }
        authService.setSecretKey(secretKey);

        Boolean authPassed = authService.auth();
        return authPassed;
    }

    protected abstract String getAccountSecretKey(String accountName) throws Throwable;
}

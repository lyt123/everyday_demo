package com.ivanlin.hmacauth;

import org.springframework.http.HttpStatus;
import org.springframework.web.context.request.RequestContextHolder;
import org.springframework.web.context.request.ServletRequestAttributes;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

public class HmacAuthService {
    private HttpServletResponse response;

    private HmacAuthHandler hmacAuthHandler;

    public HmacAuthService(HttpServletRequest request, HttpServletResponse response) {
        this.response = response;
        this.hmacAuthHandler = new HmacAuthHandler(request);
    }

    public Boolean auth() throws IOException {
        if (hmacAuthHandler.isEmptyHeaderExist()) {
            response.sendError(HttpStatus.UNAUTHORIZED.value(), "auth header is uncompleted");
            return false;
        } else if (hmacAuthHandler.isTimestampExpired()) {
            response.sendError(HttpStatus.UNAUTHORIZED.value(), "auth timestamp is expired");
            return false;
        } else if (!hmacAuthHandler.isSignatureMatched()) {
            response.sendError(HttpStatus.UNAUTHORIZED.value(), "auth signature is not matched");
            return false;
        } else {
            return true;
        }
    }

    public void setSecretKey(String secretKey) {
        hmacAuthHandler.setHmacAuthAccount(new HmacAuthAccount(getRequestAccountName(), secretKey));
    }

    public void getAccountSecretKeyFailed(Throwable throwable) throws IOException {
        response.sendError(HttpStatus.UNAUTHORIZED.value(), "auth account abnormal, error message : " + throwable.getMessage());
    }

    public static String getRequestAccountName() {
        HttpServletRequest request = ((ServletRequestAttributes) RequestContextHolder.getRequestAttributes()).getRequest();
        return request.getHeader("Authorization-Id");
    }
}

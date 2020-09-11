package com.ivanlin.hmacauth;

import lombok.Getter;
import lombok.Setter;
import org.apache.commons.lang3.StringUtils;

import javax.management.timer.Timer;
import javax.servlet.http.HttpServletRequest;
import java.util.Date;

@Getter
@Setter
public class HmacAuthHandler {

    private String authorizationTimestamp;
    private String authorizationSignature;

    private String requestUri;
    private String requestMethod;

    private HmacAuthAccount hmacAuthAccount;

    public HmacAuthHandler(HttpServletRequest request) {

        authorizationTimestamp = request.getHeader("Authorization-Timestamp");
        authorizationSignature = request.getHeader("Authorization-Signature");

        requestUri = request.getRequestURI();
        requestMethod = request.getMethod();
    }

    public String getAccountName() {
        return hmacAuthAccount.getAccountName();
    }

    public String getAccountSecretKey() {
        return hmacAuthAccount.getSecretKey();
    }

    public Boolean isEmptyHeaderExist() {
        return StringUtils.isEmpty(getAccountName()) || StringUtils.isEmpty(authorizationTimestamp) || StringUtils.isEmpty(authorizationSignature);
    }

    public boolean isTimestampExpired() {
        long currentTime = new Date().getTime();
        long authTime = Long.parseLong(authorizationTimestamp);
        return currentTime - authTime > 5 * Timer.ONE_MINUTE;
    }

    public boolean isSignatureMatched() {
        String unsignedText = generateUnsignedText();
        String targetSignature = AlgorithmUtil.digestSha1(unsignedText, getAccountSecretKey());
        return targetSignature.equals(authorizationSignature);
    }

    private String generateUnsignedText() {
        return requestMethod + "&" + requestUri + "&" + authorizationTimestamp + "&" + getAccountName();
    }

}

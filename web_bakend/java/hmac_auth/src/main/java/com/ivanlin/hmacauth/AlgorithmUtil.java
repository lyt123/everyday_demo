package com.ivanlin.hmacauth;

import javax.crypto.Mac;
import java.nio.charset.StandardCharsets;

import org.apache.commons.codec.binary.Hex;
import org.apache.commons.codec.digest.HmacAlgorithms;
import org.apache.commons.codec.digest.HmacUtils;


public class AlgorithmUtil {

    public static String digestSha1(String content, String salt) {
        return digest(content, salt, HmacAlgorithms.HMAC_SHA_1);
    }

    public static String digest(String content, String salt, HmacAlgorithms algorithm) {
        Mac mac = HmacUtils.getInitializedMac(algorithm, salt.getBytes());
        byte[] digest = mac.doFinal(content.getBytes());
        return new String(new Hex().encode(digest), StandardCharsets.ISO_8859_1);
    }
}
package com.ivanlin.hmacauth;

import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.Setter;

@Getter
@Setter
@AllArgsConstructor
public class HmacAuthAccount {
    private String accountName;
    private String secretKey;
}

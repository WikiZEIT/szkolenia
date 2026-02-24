#!/usr/bin/env python

import yaml, json

json.dump(
    yaml.safe_load(open("_config.yml"))["users"]["jcubic"]["ld"],
    open("person.json", "w"),
    indent=2,
    ensure_ascii=False
)

#!/usr/bin/env python

import yaml, json


with open("person.json", "w") as file:
    json.dump(
        yaml.safe_load(open("_config.yml"))["users"]["jcubic"]["ld"],
        file,
        indent=2,
        ensure_ascii=False
    )
    file.write("\n")

## Installation

### PEAR and git

1. Install PHPMD

```bash
pear channel-discover pear.phpmd.org
pear channel-discover pear.pdepend.org
pear install --alldeps phpmd/PHP_PMD
```

2. Clone to somewhere safe (not as root):

```bash
git clone git://github.com/tatsh/sutra-pmd-rules.git
```

3. Place the ```PHP``` directory in path that is in your PHP ```include_path```.

4. Copy ```data/PHP_PMD/resources/rulesets/sutra.xml``` to somewhere, or copy the contents to an existing ruleset.

### Gentoo

1. Install my overlay:

```bash
layman -o "http://tatsh.github.com/tatsh-overlay/layman.xml" -a tatsh-overlay
```

2. Unmask (if necessary):

```bash
echo "dev-php/phpmd ~amd64" >> /etc/portage/package.keywords
echo "dev-php/sutra-phpmd-ruleset ~amd64" >> /etc/portage/package.keywords
```

3. Install the ruleset:

```bash
emerge sutra-phpmd-ruleset
```

## How to use

### PEAR/non-Gentoo

```bash
phpmd className.php text /path/to/my-ruleset-with-sutra-rules-copied-in.xml
phpmd className.php text /path/to/sutra.xml
```

### Gentoo

On Gentoo, you can reference the ruleset in your ruleset XML file so it will be similar to this:

```xml
<?xml version="1.0"?>
<ruleset name="Sutra rule set."
  xmlns="http://pmd.sf.net/ruleset/1.0.0"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://pmd.sf.net/ruleset/1.0.0 http://pmd.sf.net/ruleset_xml_schema.xsd"
  xsi:noNamespaceSchemaLocation="http://pmd.sf.net/ruleset_xml_schema.xsd">
  <description>
    My custom rule set.
  </description>
  <rule ref="rulesets/sutra.xml"/>
</ruleset>
```

Run:

```bash
phpmd className.php text /path/to/my-ruleset.xml
```
